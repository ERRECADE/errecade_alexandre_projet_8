<?PHP
namespace App\Security;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Bundle\SecurityBundle\Security;

class TaskVoter extends Voter
{
    const EDIT = 'edit';

    public function __construct(
        private Security $security,
    ) {
    }
    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Task $task */
        $task = $subject;

        return match($attribute) {
            self::EDIT => $this->canEdit($task, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }


    private function canEdit(Task $task, User $user): bool
    { 
        if ($this->security->isGranted('ROLE_ADMIN') && $task->getUser() == null) {
            return true;
        }
        if($user === $task->getUser()){
            return true;
        }

        return false;
    }
}